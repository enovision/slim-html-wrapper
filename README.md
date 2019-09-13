## Wraps the response in an HTML container when not an Ajax call

This is required when you use the Tracy Debugger and want to show
the debugbar

This should always be the first $app middleware, for it has to
be executed last !!!

```
$app->add(new \App\Middleware\Htmlwrapper);
```
