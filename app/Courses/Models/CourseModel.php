<?php
class Course{
    private $courseId;
    private $courseName;
    private $courseIdAuthor;
    private $courseContent;
    private $courseDeleteAt;

    function setCourseData($courseId, $courseName, $courseIdAuthor, $courseContent, $courseDeleteAt){
		$this->courseId = $courseId;
        $this->courseName = $courseName;
        $this->courseIdAuthor = $courseIdAuthor;
        $this->courseContent = $courseContent;
        $this->courseDeleteAt = $courseDeleteAt;
	}

    function getCourseData(){
		return $this;
	}
}