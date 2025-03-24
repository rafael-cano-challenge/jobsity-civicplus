<?php

namespace App\UI\Http\Resources;

class ListTableDataResource
{
    protected $actions;
    protected $data;

    public function __construct(array $data, array $actions)
    {
        $this->data = $data;
        $this->actions = $actions;
    }

    public function toArray(): array
    {
        return [
            'columns' => $this->getColumns(),
            'rows' => $this->formatRows(),
        ];
    }

    protected function getColumns(): array
    {
        if (empty($this->data)) return [];

        $columns = [];
        $firstRow = $this->data[0];

        foreach ($firstRow as $key => $value) {
            $columns[] = [
                'header' => $this->headerName($key),
                'key' => $key,
            ];
        }

        $columns[] = [
            'header' => 'Actions',
            'key' => 'actions',
        ];

        return $columns;
    }

    protected function formatRows(): array
    {
        return array_map(function ($row) {
            $row['actions'] = $this->formatActions();
            return $row;
        }, $this->data);
    }

    protected function formatActions(): array
    {
        return array_map(function ($action) {
            return [
                'action' => $this->actionName($action),
                'key' => $action,
            ];
        }, $this->actions);
    }

    protected function actionName(string $key): string
    {
        return [
            'view_details' => 'See details',
        ][$key] ?? ucfirst($key);
    }

    protected function headerName(string $key): string
    {
        return ucwords(str_replace(['_', '-'], ' ', $key));
    }
}
