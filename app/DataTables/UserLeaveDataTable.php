<?php

namespace App\DataTables;

use App\Models\UserLeave;
use App\Models\Leave;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserLeaveDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            // ->addColumn('action', 'userleave.action')
            ->addColumn('action', function ($data) {

                $result = '';

                $result .= '<button class="view_btn btn btn-primary btn-sm" data-leave-id="' . $data->id . '"><i class="fas fa-eye"></i></button> &nbsp;&nbsp;';
                if ($data->status == 0) {
                    $result .= '<button class="edit_btn btn btn-primary btn-sm" data-leave-id="' . $data->id . '" data-startdatetime="' . $data->startdatetime . '" data-enddatetime="' . $data->enddatetime . '" data-leave_reason="' . $data->leave_reason . '" data-leave_status="' . $data->leave_status . '"><i class="fas fa-edit"></i></button> ';
                }
                return $result;
            })

            ->editColumn('status', function ($data) {
                if ($data->status == 0) {
                    return '<span class="badge badge-primary">Pending...</span>';
                } else if ($data->status == 1) {
                    return '<span class="badge badge-success">Approve</span>';
                } else {
                    return '<span class="badge badge-danger">Reject</span>';
                }
            })

            ->editColumn('leave_status', function ($data) {
                if ($data->leave_status == 1) {
                    return '<span class="badge badge-danger">Unpaid</span>';
                } else {
                    return '<span class="badge badge-success">Paid</span>';
                }
            })

            ->editColumn('user_id', function ($data) {
                return $data->user->name;
            })

            ->filterColumn('user_id', function ($query, $keyword) {
                $query->whereHas('user', function ($query) use ($keyword) {
                    $query->where('name', 'like', "%{$keyword}%");
                });
            })

            ->rawColumns(['action', 'status', 'leave_status','user_id'])
            ->addIndexColumn();
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Leave $model): QueryBuilder
    {
        $id = Auth::user()->id;
        return $model->with('user')->where('user_id', $id)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('userleave-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            //Column::make('no')->data('DT_RowIndex')->searchable(false)->orderable(false),
          //  Column::make('id')->hidden(),
            Column::make('startdatetime')->title('Start Date Time'),
            Column::make('enddatetime')->title('End Date Time'),
            Column::make('leave_status')->title('Leave Type'),
            Column::make('status')->title('Status'),
            Column::make('user_id')->title('User Name')->searchable(true),
            Column::make('leave_reason')->title('Leave Note'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-left'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'UserLeave_' . date('YmdHis');
    }
}
