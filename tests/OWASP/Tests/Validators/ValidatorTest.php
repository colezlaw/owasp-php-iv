<?php
namespace OWASP\Tests\Validators;

use OWASP\Validators\Validator;
use OWASP\Validators\Annotation as OWASP;
use Doctrine\Common\Annotations\Annotation;

/**
 * Validator test case.
 */
class ValidatorTest extends \PHPUnit_Framework_TestCase {

  /**
   * @var Validator
   */
  private $validator;

  private $reader;

  /**
   * Prepares the environment before running a test.
   */
  protected function setUp() {
    parent::setUp ();

    $array['value'] = TRUE;
    $this->validator = new Validator($array);
  }

  /**
   * Cleans up the environment after running a test.
   */
  protected function tearDown() {
    $this->validator = null;

    parent::tearDown ();
  }

  /**
   * Constructs the test case.
   */
  public function __construct() {
    // TODO Auto-generated constructor
  }

  /**
   * Tests Validator->getValue()
   */
  public function testGetValue() {
    $this->validator->getValue();

  }

  /**
   * Tests Validator->setValue()
   */
  public function testSetValue() {    
    $this->validator->setValue(FALSE);
  }

  public function testAnnotations(){
    $popo = new TestClassOne();
    $this->assertTrue($this->validator->Validate($popo), 'The $popo was invalid!');
  }

  /**
   * Tests Validator->__construct()
   */
  public function test__construct() {

    $this->validator->__construct(array('value'=>"test"));

  }

  /**
   * Tests Validator->__get()
   *
   * @expectedException BadMethodCallException
   */
  public function test__get() {
    $this->validator->__get('anything');
  }

  /**
   * Tests Validator->__set()
   *
   * @expectedException BadMethodCallException
   */
  public function test__set() {
    $this->validator->__set('anythingelse', TRUE);
  }
}

/**
 * A description of this class.
 *
 * Let's see if the parser recognizes that this @ is not really referring to an
 * annotation. Also make sure that @var \ is not concated to "@var\is".
 *
 * @author Bubba
 * @since 1.0
 */
class TestClassOne {
  /**
   * @var
   * @OWASP\VarType(type="string")
   */
  public $testString = "SomeTestString";

  /**
   * @return the $testString
   */
  public function getTestString() {
    return $this->testString;
  }

  /**
   * @param field_type $testString
   */
  public function setTestString($testString) {
    $this->testString = $testString;
  }

  /**
   * Constructor
   *
   * @param array $data Key-value for properties to be defined in this class
   */
  public final function __construct(array $data= NULL) {
    if (!is_null($data)) {
      foreach ($data as $key => $value) {
        $this->$key = $value;
      }
    }
  }
}
