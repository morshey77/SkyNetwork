# 🗣 ClosureAsyncTask

ClosureAsyncTask is a class that aims to create async task in closure.

## Namespace

```php
use skynetwork\core\tasks\ClosureAsyncTask;
```

## Extends

```php
extends \pocketmine\scheduler\AsyncTask;
```

## Constructor

<pre class="language-php"><code class="lang-php"><strong>/**
</strong> * @param \Closure $closure
 * @param \Closure|null $closureCompletion
 */
public function __construct(protected \Closure $closure, protected ?\Closure $closureCompletion = null)
</code></pre>
