<?php

namespace App\DataTables;

use App\Models\Leave;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LeaveDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            // ->addColumn('action', 'leave.action')

            ->addColumn('action', function ($data) {

                $result = '';

                $result .= '<button class="action-buttons view_btn btn btn-primary btn-sm" data-leave-id="' . $data->id . '"><i class="fas fa-eye"></i></button> ';
                if ($data->status == 0) {
                    $result .= '<button class="approve_btn btn btn-success btn-sm changeStatus" data-leave-id="' . $data->id . '">Approve</button>&nbsp;&nbsp;';
                    $result .= '<button class="reject_btn btn btn-danger btn-sm changeStatus" data-leave-id="' . $data->id . '">Reject</button>';
                }
                else if($data->status == 1){
                    $result .= '<button class="reject_btn btn btn-danger btn-sm changeStatus" data-leave-id="' . $data->id . '">Reject</button>';
                }
                else{
                    $result .= '<button class="approve_btn btn btn-success btn-sm changeStatus" data-leave-id="' . $data->id . '">Approve</button>&nbsp;&nbsp;';
                }

                return $result;
            })

            ->editColumn('status', function ($data) {
                if ($data->status == 0) {
                    return '<span class="badge badge-primary">Pending...</span>';
                }
                else if($data->status == 1){
                    return '<span class="badge badge-success">Approve</span>';
                }
                else {
                    return '<span class="badge badge-danger">Reject</span>';
                }
            })

            ->editColumn('leave_status', function ($data) {

                if ($data->leave_status == "1") {
                    return 'unpaid';
                } else {
                    return 'paid';
                }
            })

            ->editColumn('user_name', function ($data) {
                return $data->user->name;
            })

            ->filterColumn('user_name', function ($query, $keyword) {
                $query->whereHas('user', function ($query) use ($keyword) {
                    $query->where('name', 'like', "%{$keyword}%");
                });
            })

            ->rawColumns(['action', 'status' , 'leave_status', 'user_name'])
            ->addIndexColumn();

        // ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Leave $model): QueryBuilder
    {

        return $model->newQuery();

    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('leave-table')
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
            Column::make('no')->data('DT_RowIndex')->searchable(false)->orderable(false),
            Column::make('id')->hidden(),
            Column::make('user_name')->title('User Name')->searchable(true),
            Column::make('startdatetime')->title('Start Date Time'),
            Column::make('enddatetime')->title('End Date Time'),
            Column::make('leave_reason')->title('Leave Reason'),
            Column::make('leave_status')->title('Leave Status'),
            Column::make('status')->title('Status'),
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
        return 'Leave_' . date('YmdHis');
    }
}
