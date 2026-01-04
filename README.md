## rector-exceptions

simple [rector](https://github.com/rector/rector) to add `@throws` doccomments.

```diff
 class SomeClass
 {
+    /**
+     * @throws \InvalidArgumentException
+     */
     public function someMethod(int $arg): void
     {
         if ($arg <= 0) {
             throw new \InvalidArgumentException('argument has to be positive');
         }
         $this->someOtherMethod($arg);
     }
 }
```

this also works for other methods or functions:

```diff
 class SomeClass
 {
+    /**
+     * @throws \InvalidArgumentException
+     */
     public function someMethod(int $arg): void
     {
         if ($arg <= 0) {
             $this->throwException($arg);
         }
         $this->someOtherMethod($arg);
     }

     /**
      * @throws \InvalidArgumentException
      */
     private function throwException(int $arg): void
     {
         throw new \InvalidArgumentException("argument '$arg' is invalid);
     }
 }
```

builtin exceptions also remain fully qualified:

```diff
 use App\Exceptions\CalculationsException;

 abstract class SomeClass
 {
+    /**
+     * @throws CalculationsException
+     * @throws \RuntimeException
+     */
     public function someMethod(int $arg): void
     {
         if ($arg <= 0) {
             throw new CalculationsException($arg);
         }
         $this->someOtherMethod($arg);
     }

     /** @throws \RuntimException */
     public abstract function someOtherMethod(int $arg);
 }
```

