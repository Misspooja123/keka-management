<?php

namespace App\DataTables;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AdminUserDataTable extends DataTable
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
                if ($admin->can('adminuser_edit')) {
                    $result .= '<button class="edit_btn btn btn-primary btn-sm" data-id="' . $data->id . '"><i class="fas fa-edit"></i></button>&nbsp ';
                }
                return $result;
            })

            // ->editColumn('role_name', function ($data) {
            //     return $data->role->name;
            // })

            // ->filterColumn('role_name', function ($query, $keyword) {
            //     $query->whereHas('role', function ($query) use ($keyword) {
            //         $query->where('name', 'like', "%{$keyword}%");
            //     });
            // })

            ->rawColumns(['action'])
            ->addIndexColumn();
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Admin $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('adminuser-table')
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
            Column::make('name'),
            // Column::make('role_name'),
            Column::make('email'),
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
        return 'AdminUser_' . date('YmdHis');
    }
}
