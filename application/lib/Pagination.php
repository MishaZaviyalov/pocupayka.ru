<?php

namespace application\lib;

class Pagination
{

    private $max = 10;
    private $route;
    private $index = '';
    private $current_page;
    private $total;
    private $limit;

    /**
     * Конструктор класса Pagination
     * @param $route
     * @param $total
     * @param $limit
     */
    public function __construct($route, $total, $limit = 10)
    {
        $this->route = $route;
        $this->total = $total;
        $this->limit = $limit;
        $this->amount = $this->amount();
        $this->setCurrentPage();
    }

    /**
     * Получения разметки для создания блока пагинации
     * @return string
     */
    public function get() {
        $links = null;
        $limits = $this->limits();
        $html = '<nav><ul class="pagination">';
        for ($page = $limits[0]; $page <= $limits[1]; $page++) {
            if ($page == $this->current_page) {
                $links .= '<li class="page-item active"><span class="page-link">'.$page.'</span></li>';
            } else {
                $links .= $this->generateHtml($page);
            }
        }
        if (!is_null($links)) {
            if ($this->current_page > 1) {
                $links = $this->generateHtml(1, 'Начало').$links;
            }
            if ($this->current_page < $this->amount) {
                $links .= $this->generateHtml($this->amount, 'Конец');
            }
        }
        $html .= $links.' </ul></nav>';
        return $html;
    }

    /**
     * Генератор html разметки
     * @param $page
     * @param $text
     * @return string
     */
    private function generateHtml($page, $text = null) {
        if (!$text) {
            $text = $page;
        }
        return '<li class="page-item"><a class="page-link" href="/'.$this->route['controller'].'/'.$this->route['action'].'/'.$page.'">'.$text.'</a></li>';
    }

    /**
     *  Лимит для генератора пагинации
     * @return int[]
     */
    private function limits() {
        $left = $this->current_page - round($this->max / 2);
        $start = $left > 0 ? $left : 1;
        if ($start + $this->max <= $this->amount) {
            $end = $start > 1 ? $start + $this->max : $this->max;
        }
        else {
            $end = $this->amount;
            $start = $this->amount - $this->max > 0 ? $this->amount - $this->max : 1;
        }
        return array($start, $end);
    }

    /**
     * Установка значения маршрута
     * @return void
     */
    private function setCurrentPage() {
        if (isset($this->route['page'])) {
            $currentPage = $this->route['page'];
        } else {
            $currentPage = 1;
        }
        $this->current_page = $currentPage;
        if ($this->current_page > 0) {
            if ($this->current_page > $this->amount) {
                $this->current_page = $this->amount;
            }
        } else {
            $this->current_page = 1;
        }
    }

    /**
     * Вычисление количества для пагинации страниц
     * @return false|float
     */
    private function amount() {
        return ceil($this->total / $this->limit);
    }

}