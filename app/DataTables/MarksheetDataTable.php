<?php

namespace App\DataTables;

use App\Models\Marksheet;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MarksheetDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            ->editColumn('action', function ($data) {
                $downloadUrl = route('download.marksheet', ['id' => $data->id]);
                return '<a class="btn btn-primary btn-sm" href="' . $downloadUrl . '" target="_blank"><i class="fa fa-download"></i></a>';
            })

            ->editColumn('status', function ($data) {
                if ($data->status == 1) {
                    return '<span class="badge badge-success">Pass</span>';
                } else {
                    return '<span class="badge badge-danger">Fail</span>';
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

            ->rawColumns(['action', 'user_id', 'status'])
            ->addIndexColumn();
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Marksheet $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('marksheet-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
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
            Column::make('user_id')->title('User Name')->searchable(true),
            Column::make('total'),
            Column::make('percentage'),
            Column::make('status'),
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
        return 'Marksheet_' . date('YmdHis');
    }
}
