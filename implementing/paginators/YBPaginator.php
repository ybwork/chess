<?php

namespace paginators;

class YBPaginator implements IPaginator
{
    private $max = 10;
    private $index;
    private $current_page;
    private $total;
    private $limit;
    private $amount;

    /**
     * @param {integer} $total - number of all tasks
     * @param {integer} $current_page_number - number current page
     * @param {integer} $limit - number tasks for each page
     * @param {integer} $index - url name for pagination pages
     */
    public function __construct($total, $current_page_number, $limit, $index)
    {
        $this->total = $total;
        $this->limit = $limit;
        $this->index = $index;
        $this->amount = $this->amount();
        $this->set_current_page($current_page_number);
    }

    /**
     * Return html code for pagination
     *
     * @return {html} $html - html code for pagination
     */
    public function get()
    {
        $links = null;
        $limits = $this->limits();

        $html = '<ul class="pagination">';
        for ($page = $limits[0]; $page <= $limits[1]; $page++) {
            if ($page == $this->current_page) {
                $links .= '<li class="active"><a href="">' . $page . '</a></li>';
            } else {
                $links .= $this->generate_html($page);
            }
        }

        if (!is_null($links)) {
            if ($this->current_page > 1) {
                $links = $this->generate_html($this->current_page - 1, '&lt;') . $links;
            }
            if ($this->current_page < $this->amount) {
                $links .= $this->generate_html((int) $this->current_page + 1, '&gt;');
            }
        }
        
        $html .= $links . '</ul>';
        return $html;
    }

    /**
     * Return links for pagination
     *
     * @param {integer} $page - nubmer page
     * @return {html} links for pagination
     */
    public function generate_html($page, $text=null)
    {
        if (!$text){
            $text = $page;
        }
        
        // Удаляет пробельные (или другие символы) из конца строки
        $current_url = rtrim($_SERVER['REQUEST_URI'], '/') . '/';
        $current_url = preg_replace('~/page-[0-9]+~', '', $current_url);
        
        return '<li><a href="' . $this->index . $page . '">' . $text . '</a></li>';
    }

    /**
     * Return place for start
     *
     * @return {array} with place for start
     */
    public function limits()
    {
        // Округляет число типа float
        $left = $this->current_page - round($this->max / 2);
        $start = $left > 0 ? $left : 1;
        if ($start + $this->max <= $this->amount) {
            $end = $start > 1 ? $start + $this->max : $this->max;
        } else {
            $end = $this->amount;
            $start = $this->amount - $this->max > 0 ? $this->amount - $this->max : 1;
        }
        return array($start, $end);
    }

    /**
     * Set current page
     *
     * @param {integer} $current_page_number - nubmer current page
     */
    public function set_current_page($current_page_number)
    {
        $this->current_page = $current_page_number;
        if ($this->current_page > 0) {
            if ($this->current_page > $this->amount)
                $this->current_page = $this->amount;
        } else {
            $this->current_page = 1;
        }
    }

    /**
     * Return all number pages
     *
     * @return {integer} all number pages
     */
    public function amount()
    {
        // Округляет дробь в большую сторону
        return ceil($this->total / $this->limit);
    }
}