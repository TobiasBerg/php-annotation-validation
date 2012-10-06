<?php
/**
 *
 */
class Repli_Validation
{
	/**
	 * Method for validating
	 */
	public function ValidateObject($object)
	{
		$properties = $this->GetClassProperties(get_class($object));

		$propertyAnnotations = array();

		foreach($properties as $property)
		{
			$propertyAnnotation = $this->GetPropertyAnnotations($property, get_class($object));
			$propertyAnnotations[] = $propertyAnnotation;

			foreach ($propertyAnnotation as $annotation) {
				$annotation = str_replace('type ', '', $annotation);

				$errors = array();

				if (strpos($annotation, 'string') !== false) {
					$errors[] = $this->ValidateString($annotation);
				}

				if (strpos($annotation, 'int') !== false) {
					$errors[] = $this->ValidateInt($annotation);
				}

				if (strpos($annotation, 'required') !== false) {
					$errors[] = $this->ValidateNullOrEmpty($annotation);
				}

				if (empty($errors)) {
					echo 'SUCCESS';
				}
			}
		}
	}

	/**
	 * Getting class properties in a Reflection Object.
	 */
	private function GetClassProperties($class)
	{
		$r = new ReflectionClass($class);
		$properties = $r->getProperties();

		return $properties;
	}

	/**
	 * Gets the actual Annotations of the properties.
	 */
	private function GetPropertyAnnotations($property, $className)
	{
		$annotation = $property->GetDocComment();

		preg_match_all('#@(.*?)\n#s', $annotation, $annotations);

		$trimmedAnnotation = array();
		foreach ($annotations[1] as $key => $value) {
			$trimmedAnnotation[] = trim($value);
		}

		return $trimmedAnnotation;
	}

	private function ValidateString($value)
	{

	}

	private function ValidateInt($value)
	{

	}

	private function ValidateNullOrEmpty($value)
	{

	}
}
?>
