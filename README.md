# Object validation with replication in PHP

For a project I wanted easy and consistent validation of my objects.

## Usage

On the properties of your object you add doc-block style comments to
set validation setting on that property like so:

```php
class model {

	/**
	 *
	 * @required
	 * @type int
	 */
	 public $id;
}
```
