<?php
class CourseControl{
    private $model;
    private $view;

    function __construct($model, $view)
    {
        $this->model = $model;
        $this->view = $view;
    }

    function updateView(){
		$this->view->printTableCourses();
	}
}