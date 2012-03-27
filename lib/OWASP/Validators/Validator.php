<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <https://www.owasp.org/>.
 */

namespace OWASP\Validators;

use Doctrine\Common\Annotations\AnnotationRegistry;

use Doctrine\Common\Annotations\AnnotationReader;
use OWASP\Validators\Annotation;
use OWASP\Validators\Validator as Validator;
/*
 * Validator class
 *
 * @author  Bubba Hines <bubba@hines57.com>
 * 
 */
class Validator
{
	private $value;
	
	private $reader;
    
	public function Validate($object){
		$reader = $this->reader;
		$class = new \ReflectionClass(get_class($object));
		//print_r($reader->getClassAnnotations($class));
		
		$props = $class->getProperties();
		foreach ($props as $prop){
			$anotations = $reader->getPropertyAnnotations($prop);
			foreach ($anotations as $anot){
				if (get_class($anot) == 'OWASP\Validators\Annotation\VarType'){
					return Validator\VarType::validate($object->{$prop->name}, $anot->type);
				}
			}
		}
		
		$methods = $class->getMethods();
		foreach ($methods as $method){
			//print_r($reader->getMethodAnnotations($method));
		}
	}
    
    /**
	 * @return the $value
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @param string $value
	 */
	public function setValue($value) {
		$this->value = $value;
	}

	/**
     * Constructor
     *
     * @param array $data Key-value for properties to be defined in this class
     */
    public final function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        AnnotationRegistry::registerFile(__DIR__ . '/Annotation/VarType.php');
        $this->reader = new AnnotationReader();
    }

    /**
     * Error handler for unknown property accessor in Validator class.
     *
     * @param string $name Unknown property name
     */
    public function __get($name)
    {
        throw new \BadMethodCallException(
            sprintf("Unknown property '%s' on validator '%s'.", $name, get_class($this))
        );
    }

    /**
     * Error handler for unknown property mutator in Validator class.
     *
     * @param string $name Unkown property name
     * @param mixed $value Property value
     */
    public function __set($name, $value)
    {
        throw new \BadMethodCallException(
            sprintf("Unknown property '%s' on validator '%s'.", $name, get_class($this))
        );
    }
}