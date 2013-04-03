<?php
class Annotation_Validation
{
	public function isObjectValid($object)
	{
		if (!$object->validated) {
			$object = $this->validateObject($object);
		}

		if (in_array(false, $object->validated)) {
			return false;
		}

		return true;
	}

	public function validateObject($object)
	{
		$properties = $this->_getClassProperties(get_class($object));
		$propertyAnnotations = array();

		foreach($properties as $property)
		{
			$propertyAnnotations = $this->_getPropertyAnnotations($property, get_class($object));

			foreach ($propertyAnnotations as $propertyAnnotation) {
				$annotation = str_replace('type ', '', $propertyAnnotation);

				$object->validated[$property->name] = $this->_validateProperty($annotation);
			}
		}

		return $object;
	}

	private function _validateProperty($annotation)
	{
		if (strpos($annotation, 'string') !== false) {
			return $this->_validateString($annotation);
		}

		if (strpos($annotation, 'int') !== false) {
			return $this->_validateInt($annotation);
		}

		if (strpos($annotation, 'required') !== false) {
			return $this->_validateNullOrEmpty($annotation);
		}
	}

	private function _getClassProperties($class)
	{
		$ReflectionClass = new ReflectionClass($class);
		$properties = $ReflectionClass->getProperties();

		return $properties;
	}

	private function _getPropertyAnnotations($property, $className)
	{
		$annotation = $property->getDocComment();

		preg_match_all('#@(.*?)\n#s', $annotation, $annotations);

		$trimmedAnnotation = array();
		foreach ($annotations[1] as $key => $value) {
			$trimmedAnnotation[] = trim($value);
		}

		return $trimmedAnnotation;
	}

	private function _validateString($value)
	{
		return is_string($value);
	}

	private function _validateInt($value)
	{
		return is_int($value);
	}

	private function _validateNullOrEmpty($value)
	{
		return empty(trim($value));
	}
}
?>
