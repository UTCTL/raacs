<?php
require_once 'Zend/Amf/Server.php';
//Zend_Amf_Server extended to add fault code numbers to ACL Exceptions so they can be used in the Flash Application


class RaacsAmfServer extends Zend_Amf_Server
{
	/**
     * Check if the ACL allows accessing the function or method
     *
     * @param string|object $object Object or class being accessed
     * @param string $function Function or method being acessed
     * @return unknown_type
     */
    protected function _checkAcl($object, $function)
    {
        if(!$this->_acl) {
            return true;
        }
        if($object) {
            $class = is_object($object)?get_class($object):$object;
            if(!$this->_acl->has($class)) {
                require_once 'Zend/Acl/Resource.php';
                $this->_acl->add(new Zend_Acl_Resource($class));
            }
            $call = array($object, "initAcl");
            if(is_callable($call) && !call_user_func($call, $this->_acl)) {
                // if initAcl returns false, no ACL check
                return true;
            }
        } else {
            $class = null;
        }

        $auth = Zend_Auth::getInstance();
		
        if($auth->hasIdentity()) {
            $role = $auth->getIdentity()->role;
        } else {
            if($this->_acl->hasRole(Zend_Amf_Constants::GUEST_ROLE)) {
                $role = Zend_Amf_Constants::GUEST_ROLE;
            } else {
                require_once 'Zend/Amf/Server/Exception.php';
                throw new Zend_Amf_Server_Exception("Unauthenticated access not allowed",311001); //Fault Code Added
            }
        }
        if($this->_acl->isAllowed($role, $class, $function)) {
            return true;
        } else {
            require_once 'Zend/Amf/Server/Exception.php';
            throw new Zend_Amf_Server_Exception("Access not allowed",311002); //Fault Code added
        }
    }

}
?>