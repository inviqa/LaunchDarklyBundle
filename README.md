# LaunchDarkly Bundle

## Note

This is not a stable release, there may well be things that need fixing and B/C breaks to come.

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

The bundle needs to be registered in AppKernel:

```
// app/AppKernel.php

public function registerBundles()
{
    $bundles = [
        //...
        new new Inviqa\LaunchDarklyBundle\InviqaLaunchDarklyBundle(),
    ];
}

```

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
if ($this->get('inviqa_launchdarkly.client')->variation('my-flag')) {
    //new feature
}
```

## Flag in code

Checking flags in conditionals is the simplest approach to get started with. It may not be the best approach for maintainability though and 
other options are provided below.

### Passing default

A default value can be passed which will be used if an error is encountered, for example, if the feature flag key doesn't exist or the user doesn't have a key specified. This defaults to false.

```php
if ($this->get('inviqa_launchdarkly.client')->variation('my-flag', true)) {
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
if (Inviqa\LaunchDarklyBundle\Client\StaticClient::variation('my-flag', true)) {
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

Rather than including conditionals in code you may prefer to inject alternative versions of services (and then remove the old service altogether once the flag is always on).

This can be done at the level of defining arguments for a service using an expression language function:

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

Here the `inviqa_launchdarkly.test_service` service id will be an alias for the `inviqa_launchdarkly.new_test_service` if the `new-service-content` flag is on and an alias for the
`inviqa_launchdarkly.old_test_service` if it is off. This allows you 
to define the change in a single place and have it affect all places
where the `inviqa_launchdarkly.test_service` service is used.

A shorter but hackier (the way it is processed by the bundle is hackier) alternative is to use:

```
inviqa_launchdarkly.test_service:
        alias: "new-aliased-service-content?inviqa_launchdarkly.new_test_service:inviqa_launchdarkly.old_test_service"
```

## User id provider service

The user id/key used when requesting a flag's value is provided by a service which needs implement the `\Inviqa\LaunchDarklyBundle\User\KeyProvider` Interface:

```php
interface KeyProvider
{
    public function userKey();
}
```

This should return a string value representing the user uniquely, for example their username or if anonymous their session id. The default implementation uses the session id. To use an alternative service create the service definition as normal using whatever id you would like and then set that as the value for the `user_key_provider_service ` key in the bundle config:

```
inviqa_launch_darkly:
    api_key: MYAPIKEY
    user_key_provider_service: my_user_key_provider_sevice
```

## User factory service

Only the id/key returned from the user id provider service will be sent to LaunchDarkly by default. You can send further information which allows you to fine tune which user the flag is on for. This can be done by providing an alternative implementation of the user factory service which needs to implement the `\Inviqa\LaunchDarklyBundle\User\UserFactory` interface:

```php
interface UserFactory
{
    public function create($key);
}
```

This should return an `\LaunchDarkly\LDUser` object. There is a builder (`\LaunchDarkly\LDUserBuilder`) for the LDUser which can be used to simplify this. The service then needs a definition creating as usual and the id provided as the value for the `user_factory_service ` key in the config:

```
inviqa_launch_darkly:
    api_key: MYAPIKEY
    user_factory_service: my_user_factory_sevice
```

For example, if we wanted to send the ip address of the user as well we could create an implementation like this:

EXAMPLE

### Passing the user key explicitly

If the user is not available implicitly from the session (or some other means) then 
you can pass it directly using the 

```
inviqa_launchdarkly.user_client
```

service. For example:

```php
if ($this->get('inviqa_launchdarkly.user_client')->variation('my-flag', new LDClient('the-user-id'))) {
    //new feature
}
```

or with an alternative static client:

```php
if (Inviqa\LaunchDarklyBundle\Client\ExplicitUser\StaticClient::variation('my-flag', new LDClient('the-user-id'))) {
    //new feature
}
```

When using these versions of the client the User id provider service and User factory service will not be used.


## Debug toolbar

The flags requested, and whether they were requested in a template, as a service or in code is captured and shown in the debug toolbar.

## Full Configuration

The full configuration is below. The `base_uri`, `timeout`, `connect_timeout`, `events` and `defaults` keys are all settings for the LaunchDarkly client itself. See [http://docs.launchdarkly.com/docs/php-sdk-reference]() for details. 

```
# Default configuration for extension with alias: "inviqa_launch_darkly"
inviqa_launch_darkly:  # Required
    api_key:              ~ # Required
    base_uri:             ~
    user_factory_service:  inviqa_launchdarkly.simple_user_factory
    user_key_provider_service:  inviqa_launchdarkly.session_key_provider
    feature_requester_class:  ~
    timeout:              ~
    connect_timeout:      ~
    capacity:             ~
    events:               ~
    defaults:

        # Prototype
        flag:                 ~
```
        
## Full client

You can also use the full client service to access other methods on the LDClient (see [http://docs.launchdarkly.com/docs/php-sdk-reference]()). This has a service id of `inviqa_launchdarkly.inner_client`.

## Todo

* A user id provider service that integrates with the security user
* Integration with routing to handle routes with different controllers dependant on flag value
* Integration with event listeners/subscribers to allow registering dependant on flag value
* Integration with event listeners/subscribers to allow registering dependant on flag value
* Integration with security to allow things with roles to be dependant on flag values if that makes sense
as a useful thing
