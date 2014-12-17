IO Component
=================

IO Component greatly provide some base classes as streams, serialization and the file system for System Input and output. 

If you are familiar with java.io in JDK, you might get started to use this component quickly.

In addition this component provides common filesystem features needed to any useage case in stream programming style:

```php
$input = Chigi\Component\IO\StdInputStream::getInstance();
echo $input->readLine();
```

Besides, you could create your io utils with stream operation supports by extends the Base Stream Classes easily:

```php
class RoboOutputStream extends \Chigi\Component\IO\OutputStream {

    protected function writeString($string) {
        \Robo\Runner::getPrinter()->write($string);
    }

    public function close() {
        
    }

    public function flush() {
        
    }

}
```

Then the new stream from your self could be used at any FileSystem IO, Network Socket IO script logic directly. Seems exciting right?

This component provides a log of abstract base classes and interfaces like InputStream, OutputStream, EOFException, ...

# Resources

<!-- [The Console Component](http://symfony.com/doc/current/components/console.html) -->