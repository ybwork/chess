<?php

namespace paginators;

interface IPaginator
{
    public function __construct($total, $current_page_number, $limit, $index);
    public function get();
    public function generate_html($page, $text);
    public function limits();
    public function set_current_page($current_page_number);
    public function amount();
}