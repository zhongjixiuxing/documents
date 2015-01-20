<?php
class MyReflection{

    public function getReflectionClass($classname){
      return new ReflectionClass($classname);
    }
}
