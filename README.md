![Build status](https://travis-ci.org/Hgazibara/StringIO.svg)

StringIO
========

This is a PHP version of Python's [StringIO](https://docs.python.org/2/library/stringio.html), which is also available in languages like [Ruby](http://ruby-doc.org/stdlib-1.9.3/libdoc/stringio/rdoc/StringIO.html) and [Go](https://code.google.com/p/go-stringio/). It's implemented as a `StringIO` stream wrapper, with a fictional protocol `stringio`.

The code is not yet fully finished, but the wrapper might still be useful for some simple unit testing when there is a need to simulate read/write behaviour of a file or stream.

In the future versions it will be possible to pre-populate stream with soma data to enable mocking non-empty file.

Since this wrapper only tries to act as a substitute for a simple file, there is a [vfsStream](https://github.com/mikey179/vfsStream) stream wrapper, which provides more complex use cases.
