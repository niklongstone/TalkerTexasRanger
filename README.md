&#9055; Talker Texas Ranger
===================

Talker Texas Ranger will let your class talk :-)

Usage
-----

Given the following class:
```
class TestClass {
    public function testMethod($first, $second)
    {
        echo sprintf("testMethod call with first=%s and second=%s", $first, $second);
    }
}
```

You can perform a call with:
```
$talker = new Talker(new TestClass());
$talker->call('test Method "1" and "2"'); 

//OUPUT:
//testMethod call with first=1 and second=2  
```