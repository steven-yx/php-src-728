--TEST--
Test that the Hprose\RawReader class works.
--SKIPIF--
<?php if (!extension_loaded("hprose")) print "skip"; ?>
--FILE--
<?php
class User {
    private $id = 1;
    public $name = "默认用户";
    public $age = 18;
}
date_default_timezone_set('Asia/Shanghai');
$bytes = new HproseBytesIO();
$writer = new HproseWriter($bytes, true);
$reader = new HproseRawReader($bytes);
$writer->serialize(0);
$writer->serialize(1);
$writer->serialize(2);
$writer->serialize(3);
$writer->serialize(4);
$writer->serialize(5);
$writer->serialize(6);
$writer->serialize(7);
$writer->serialize(8);
$writer->serialize(9);
$writer->serialize(-2147483648);
$writer->serialize(2147483647);
$writer->serialize(2147483648);
$writer->serialize(3.1415926535898);
$writer->serialize(log(-1));
$writer->serialize(log(0));
$writer->serialize(-log(0));
$writer->serialize(true);
$writer->serialize(false);
$writer->serialize("");
$writer->serialize(null);
$writer->serialize("我");
$writer->serialize("🆚");

echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";

$bytes->close();
unset($writer);
$writer = new HproseWriter($bytes);
$date = new DateTime('2015-02-19T14:34:48.123456');
$writer->serialize($date);
$writer->serialize(new DateTime('2015-02-19T14:34:48.123456',
                                 new DateTimeZone('UTC')));
$writer->serialize($date);
$writer->serialize("Hello World! 你好，中国！");
$writer->serialize("Hello World! 你好，中国！");

echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";

$bytes->close();
$writer->reset();
$writer->serialize(array(1,2,3,4,5));
$writer->serialize(array("Apple", "Banana", "Cherry"));
$writer->serialize(array("Apple"=>"苹果", "Banana"=>"香蕉", "Cherry"=>"樱桃"));
$sos = new SplObjectStorage();
$sos->attach($date, array("Apple", "Banana", "Cherry"));
$sos->attach($sos, $date);
$writer->serialize($sos);
$sfa = new SplFixedArray(3);
$sfa[0] = "昨天";
$sfa[1] = "今天";
$sfa[2] = "明天";
$writer->serialize($sfa);
$stdobj = new stdClass();
$stdobj->name = "张三";
$stdobj->age = 18;
$writer->serialize($stdobj);
$writer->serialize(new User());

echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
echo $reader->readRaw() . "\r\n";
?>
--EXPECT--
0
1
2
3
4
5
6
7
8
9
i-2147483648;
i2147483647;
l2147483648;
d3.1415926535898;
N
I-
I+
t
f
e
n
u我
s2"🆚"
D20150219T143448.123456;
D20150219T143448.123456Z
r0;
s19"Hello World! 你好，中国！"
r2;
a5{12345}
a3{s5"Apple"s6"Banana"s6"Cherry"}
m3{r2;s2"苹果"r3;s2"香蕉"r4;s2"樱桃"}
m2{D20150219T143448.123456;a3{r2;r3;r4;}r9;r10;}
a3{s2"昨天"s2"今天"s2"明天"}
m2{s4"name"s2"张三"s3"age"i18;}
c4"User"3{s2"id"r17;r19;}o0{1s4"默认用户"i18;}