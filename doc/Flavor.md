Flavor
======


## Flavor Loader

To create a flavor loader object:

    $loader = new Flavor\FlavorLoader;

    $loader = new Flavor\FlavorLoader( array( 'path/to/your/flavors', 'path/to/your/flavors2' ) );

To load a flavor by the flavor loader:

    $flavor = $loader->load( $flavorName );

To get the generator object from flavor:

    $generator = $flavor->getGenerator();


