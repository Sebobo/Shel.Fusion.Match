# Neos Fusion helper to simplify string matching

[![Latest Stable Version](https://poser.pugx.org/shel/fusion-match/v/stable)](https://packagist.org/packages/shel/fusion-match)
[![Total Downloads](https://poser.pugx.org/shel/fusion-match/downloads)](https://packagist.org/packages/shel/fusion-match)
[![License](https://poser.pugx.org/shel/fusion-match/license)](https://packagist.org/packages/shel/fusion-match)

This package provides a Fusion object to simplify common string matching.

Inspired by the [PHP 8 match expression](https://www.php.net/manual/tr/control-structures.match.php).

The goal for this plugin is to provide the given functionality to [Neos CMS](https://www.neos.io) >= 4.3 
and hopefully add it as a feature to the Neos core in a future Neos release > 6.0.
 
## Installation

Run the following command in your site package:

```
composer require --no-update shel/fusion-match
```                                            

Then run composer update in your project root.

## Examples

### Basic

The following Fusion code is very verbose and has repetitions:

```
rowClass = Neos.Fusion:Case {
    case1 {
      condition = ${q(node).property('columns') == "one"}
      renderer = "d-flex col-12 col-md-6 col-lg-12"
    }
    case2 {
      condition = ${q(node).property('columns') == "two"}
      renderer = "d-flex col-12 col-md-6 col-lg-6"
    }
    case3 {
      condition = ${q(node).property('columns') == "three"}
      renderer = "d-flex col-12 col-md-6 col-lg-4"
    }
    case4 {
      condition = ${q(node).property('columns') == "four"}
      renderer = "d-flex col-12 col-md-6 col-lg-3"
    }
}
```

With the `Match` object this becomes compact and readable:

```
rowClass = Shel.Fusion:Match {
    @subject = ${q(node).property('columns')}
    one = 'd-flex col-12 col-md-6 col-lg-12'
    two = 'd-flex col-12 col-md-6 col-lg-6'
    three = 'd-flex col-12 col-md-6 col-lg-4'
    four = 'd-flex col-12 col-md-6 col-lg-3'
}
```     

### Providing a default

You can also provide a default via `@default`:

```
rowClass = Shel.Fusion:Match {
    @subject = ${q(node).property('layout')}
    @default = ''
    left = 'my-module--left'
    right = 'my-module--right'
}
```    

### Other return types

```
myVar = Shel.Fusion:Match {
    @subject = ${q(node).property('someProperty')}
    @default = ''
    case1 = afx`
        <div>hello world</div>     
    `
    case2 = 'hello world'
    case3 = Neos.Fusion:Value {
        value = 'hello world'
    }           
    case4 = Neos.Fusion:DataStructure {
        my = 'array'
    } 
}
```

Make sure all cases return the same type, or you will get into trouble 😉   

### Usage in AFX

```     
myVar = 'test' 
renderer = afx`
    <div>
        <Shel.Fusion:Match @subject={props.myVar}>
            <span @path="test">Hello world</span>
            <span @path="@default">No match found</span>
        </Shel.Fusion:Match>
    </div>
`    
```

## Type checking and error handling

The object expects to find a match. Either one of the provided cases or the default.
If no case matches and no default has been provided an exception will be raised.

The `subject` will be casted to a string. 
If a `subject` is provided that cannot be casted to a string it will also cause an error.

The matchable cases also will be cast to a string. So you can use strings or numbers.

  
