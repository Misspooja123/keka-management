<?php

namespace App\DataTables;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;

class AttendanceDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable($query, Request $request): EloquentDataTable
    {
        $admin = Auth()->guard('admin')->user();
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function ($data) use ($admin) {
                $result = "";

                if ($admin->can('attendance_edit')) {
                    $result .= '<button class="edit-btn btn btn-primary btn-sm" title="Edit Attendance" data-toggle="modal" data-target="#product_edit_modal"  data-starttime="' . $data->starttime . '" data-endtime="' . $data->endtime . '" data-id="' . $data->id . '"><i class="fa fa-edit"></i></button>';
                }
                return $result;
            })

            ->editColumn('status', function ($data) {
                if ($data->status == 1) {
                    return '<span class="badge badge-success">Clock-in</span>';
                } else {
                    return '<span class="badge badge-danger">Clock-out</span>';
                }
            })

            ->rawColumns(['action', 'status'])
            ->addIndexColumn();
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Attendance $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('attendance-table')
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
            Column::make('user_name'),
            Column::make('starttime'),
            Column::make('endtime'),
            Column::make('status'),
            Column::make('description'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Attendance_' . date('YmdHis');
    }
}
