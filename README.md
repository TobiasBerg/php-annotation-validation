# Object validation with reflection in PHP

A simple way of validating properties of models with the help of annotations.

## Usage

On the properties of your object you add annotations to
set validation settings on that property like so:

```php
class model {

	/**
	 * @required
	 * @type int
	 */
	 public $id;

	 /**
	 * @type string
	 */
	 public $name;
}
```

When validating the object this will set a ->validated property which holds the validation status for the properties.

```php
$validatedModel = $annotationValidation->validateObject($object);
```

The object will then look like this:

```
object(model)[2]
  public 'id' => 123
  public 'name' => 'PHP'
  public 'validated' => 
    array (size=2)
      'id' => boolean true
      'name' => boolean true
```

You can check if an object is valid by calling

```php
$isValid = $annotationValidation->isObjectValid($object);
```
