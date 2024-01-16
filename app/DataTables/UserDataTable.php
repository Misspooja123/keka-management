<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $admin = Auth()->guard('admin')->user();
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($data) use ($admin) {

                $result = '';
                if ($admin->can('employee_edit')) {
                    $result .= '<button class="edit_btn btn btn-primary btn-sm" data-id="' . $data->id . '"><i class="fas fa-edit"></i></button>&nbsp ';
                }
                if ($admin->can('employee_delete')) {
                    $result .= '<button class="delete-btn btn btn-danger btn-sm" data-id="' . $data->id . '"><i class="fas fa-trash"></i></button>&nbsp&nbsp';
                }
                if ($data->status == 1) {
                    $result .= '<button class="status-btn btn btn-success btn-sm" data-id="' . $data->id . '" data-status="1"><i class="fas fa-toggle-on"></i> </button>';
                } else {
                    $result .= '<button class="status-btn btn btn-secondary btn-sm" data-id="' . $data->id . '" data-status="0"><i class="fas fa-toggle-off"></i> </button>';
                }
                return $result;
            })
            ->editColumn('department_id', function ($data) {
                return $data->department->name;
            })

            ->editColumn('status', function ($data) {
                if ($data->status == 0) {
                    return '<span class="badge badge-secondary">Inactive</span>';
                } else {
                    return '<span class="badge badge-success">Active</span>';
                }
            })
            ->filterColumn('department_id', function ($query, $keyword) {
                $query->whereHas('department', function ($query) use ($keyword) {
                    $query->where('name', 'like', "%{$keyword}%");
                });
            })

            ->rawColumns(['action', 'status'])
            ->addIndexColumn();
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('employee-table')
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
            Column::make('name')->title('User Name')->searchable(true),
            Column::make('department_id')->title('Department Name'),
            //  Column::make('department.name')->title('Department Name'),
            Column::make('email')->title('Email'),
            Column::make('mobile_no')->title('Mobile No'),
            Column::make('address')->title('Address'),
            Column::make('status')->title('Status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-left'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Employee_' . date('YmdHis');
    }
}
