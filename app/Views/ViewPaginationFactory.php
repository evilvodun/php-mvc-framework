<?php
namespace App\Views;

class ViewPaginationFactory
{
    protected $view;

    protected $rendered;
    
    public function __construct(View $view)
    {
        $this->view = $view; 
    }
    
    public function make($view, $data = [])
    {
        $this->rendered = $this->view->make($view, $data);
        return $this->rendered;
    }

    // public function render()
    // {
    //     return $this->rendered;
    // }
}