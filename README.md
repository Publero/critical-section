CriticalSection PHP library
===========================

[![Build Status](https://travis-ci.org/Publero/critical-section.png?branch=master)](https://travis-ci.org/Publero/critical-section)

This library handles problem of code critical section which should be executed only once at a time.

Example use case
----------------

You have a cron task that is executing every minute, but it takes some time to execute. When server load's go critical it can take more
than minute, which leads to bugs as a same cron is executed in multiple process at the same time.

You can encapsulate this code into critical section with use of this library.

``` php
$criticalSection = new CriticalSection();

$criticalSection->enter('cron_long_task');
doSomething();
$criticalSection->leave('cron_long_task');
```

This code example does take care of critical sections. You say which critical section should be entered. In this case
it is `cron_long_task`. No other script can enter this critical section until the original one leaves the critical section.
Keep in mind that critical section is left even if the script ends, or `CriticalSection` object is destructed.

If you want to enter critical section you can't script will wait until it can be entered. If you need to skip code which
is already in critical section use timeout or `canEnter` method.

Timeout critical section
------------------------

You can also do timeout enter. This way you can say explicitly say how long should the script wait to enter critical section.
This is useful if you want to do something, but you know it only make sense in some time interval.

``` php
$criticalSection = new CriticalSection();

$code = __FILE__;
if ($criticalSection->enter($code, 30)) {
    doSomething();
    $criticalSection->leave($code);
}
```

Keep in mind that you have to check if enter returned true if you use timeout.

Check if code can enter critical section
----------------------------------------

If you are using everyminute cron (or even faster), we can assume that you can skip one or two calls here and there.
To do so you can check if critical section can be entered before entering it.

``` php
$criticalSection = new CriticalSection();

$code = __FILE__;
if ($criticalSection->canEnter($code)) {
    $criticalSection->enter($code);
    doSomething();
    $criticalSection->leave($code);
}
```

Another way to do so is to enter critical section with zero timeout.

``` php
$criticalSection = new CriticalSection();

$code = __FILE__;
if ($criticalSection->enter($code, 0)) {
    doSomething();
    $criticalSection->leave($code);
}
```

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    LICENSE

Reporting an issue or a feature request
---------------------------------------

Issues and feature requests are tracked in the [Github issue tracker](https://github.com/Publero/critical-section).
