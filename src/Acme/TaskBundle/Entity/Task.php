<?php
//src/Acme/TaskBundle/Entity/Task.php

namespace Acme\TaskBundle\Entity;

class Task 
{
	// Descripcion de la tarea
	protected $task;

	// Fecha en la que debe estar completada
	protected $dueDate;

	protected $category;

	public function getTask()
	{
		return $this->task;
	}

	public function setTask($task) {
		$this->task = $task;
		return $this;
	}

	public function getDueDate() 
	{
		return $this->dueDate;
	}

	public function setDueDate($dueDate){
		$this->dueDate = $dueDate;
		return $this;
	}

	public function getCategory(){
		return $this->category;
	}

	public function setCategory(Category $category = null)
	{
		$this->category = $category;
		return $this;
	}
}