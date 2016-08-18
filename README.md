# LaunchDarkly Bundle

## Introduction

A Symfony bundle to integrate the PHP client for [LaunchDarkly](https://launchdarkly.com), 
a Feature flag management service. 

Documentation for the PHP Client library can be found at 
[http://docs.launchdarkly.com/docs/php-sdk-reference]()

## Installation

```
$ composer require inviqa/launchdarkly-bundle
```

The flags need to be fetched somehow. The simplest option is using 
Guzzle to make HTTP requests. A more complicated but more performant 
option is to to use the [ld-daemon](https://github.com/launchdarkly/ld-daemon)  
to store the flags in Redis and then access them from 
there. There are further dependencies for each of these options:

### Guzzle

```
$ composer require "guzzlehttp/guzzle:6.2.1"
$ composer require "kevinrob/guzzle-cache-middleware": "1.4.1"
```

### Redis and ld-bundle

```
$ composer require "predis/predis": "1.0.*"
```

The set up of [ld-daemon](https://github.com/launchdarkly/ld-daemon) 
also needs to be done.

## Simplest config and example

The minimum config needed is to provide your API Key:

```
#app/config/config.yml

inviqa_launch_darkly:
    api_key: APIKEY
```

Note: In practice different API keys are used for different 
environments so making it a parameter will be the way to go.

A flag can then be checked using a flag service:

```php
if ($this->get('inviqa_launchdarkly.client')->isOn('my-flag')) {
    //new feature
}
```

## Flag in code

Checking flags in conditionals is the simplest approach to get started with. It may not be the best approach for maintainability though and 
other options are provided below.

### Passing default

A default value can be passed which will be used UNDER SOME CURCUMSTANCES. This defaults to false.

```php
if ($this->get('inviqa_launchdarkly.client')->isOn('my-flag', true)) {
    //new feature
}
```

### Service

You can inject the service into other classes as well as retrieving it 
from the container in a controller using the usual Symfony service configuration:

```xml
<service id="my-service" class="MyClass">
	<argument type="service" id="inviqa_launchdarkly.client"/>
</service>
```

### Static Access

There is also static access to check a flag, whilst this is generally 
frowned upon it may be preferable to the boilerplate of injecting the 
service and the associated config since this is temporary code that 
should be removed once the flag value is no longer changed:

```php
if (StaticClient::isOn->isOn('my-flag', true)) {
    //new feature
}
```

## Twig extension

There is a twig function which allows you to check flags from templates:

```
{% if isFlagOn("new-template-content") %}
    <p>the new template content</p>
{% else %}
    <p>the old template content</p>
{% endif %}
```

or passing a default value:

```
{% if isFlagOn("new-template-content", true) %}
    <p>the new template content</p>
{% else %}
    <p>the old template content</p>
{% endif %}
```

## Service configuration

Rather than including conditionals in code you may prefer to inject alternative versions
of services (and then remove the old service altogether once the flag is always on).

This can be done at the level of defining arguments for a service using an expression
language function:

```
 inviqa_launchdarkly.test_service:
        class: OuterService
        arguments: ["@=toggle('new-service-content', 'inviqa_launchdarkly.new_test_service', 'inviqa_launchdarkly.old_test_service')"]
```

Where the first argument (`new-service-content`) is the flag, the 
second (`inviqa_launchdarkly.new_test_service`) is the service to 
inject if it is on and the third 
(`inviqa_launchdarkly.old_test_service`) is the service to use if the 
flag is off.

Alternatively you can change which service a service id points at, 
similar to how aliases work but determined by a flag value. This can 
be done using a tag:

```
inviqa_launchdarkly.test_service:
    class: TestService
    tags:
        - name: inviqa_launchdarkly.toggle
          flag: new-service-content
          active-id: inviqa_launchdarkly.new_test_service
          inactive-id: inviqa_launchdarkly.old_test_service
```

Here the `inviqa_launchdarkly.test_service` service id will be an alias for the
`inviqa_launchdarkly.new_test_service` if the `new-service-content` flag is on
and an alias for the `inviqa_launchdarkly.old_test_service` if it is off. This
allows you to dfeine the change in a single place and have it affect all places
where the `inviqa_launchdarkly.test_service` service is used.

A shorter but hackier (the way it is processed by the bundle is hackier) alternative
is to use:

```
inviqa_launchdarkly.test_service:
        alias: "new-aliased-service-content?inviqa_launchdarkly.new_test_service:inviqa_launchdarkly.old_test_service"
```

## User id provider service
## User factory service
## Debug toolbar
## Full Configuration
## Full client
## Testing
## Todo

* A user id provider service that integrates with the security user
* Integration with routing to handle routes with different controllers dependant on flag value
* Integration with event listeners/subscribers to allow registering dependant on flag value
* Integration with event listeners/subscribers to allow registering dependant on flag value
* Integration with security to allow things with roles to be dependant on flag values if that makes sense
as a useful thing
