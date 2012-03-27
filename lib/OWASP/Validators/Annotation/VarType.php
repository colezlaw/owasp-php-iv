<?php 
namespace OWASP\Validators\Annotation;

use Doctrine\Common\Annotations as Doctrine;

/** 
 * @Annotation 
 * @Target("PROPERTY")
 */
class VarType extends Doctrine\Annotation {
    public $type;
}