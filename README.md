# Zf1-futures
This is a fork from https://github.com/Shardj/zf1-future which is aiming supporting PHP81 with the abandoned ZendFramework1.

# Actionstep ZendFramework1
We should only use branch `actionstep` for `platform` code.
This branch bases on the `master` branch of zf1-future, and gets applied with a few "hacks" done by Actionstep in the past.

Any "hacks" should be noted in the list below.

# Hacks
- \Zend_Mail_Protocol_Smtp::data
- \Zend_Http_Client_Adapter_Proxy::connectHandshake
- \Zend_Session::_checkId
- \Zend_Mime_Decode::splitMessage
- \Zend_Mail_Part::__construct
- \Zend_Mail_Part::_validateHeaders (why? the only call to this is enabled in the __construct)
- \Zend_Service_Amazon_S3::_validBucketName
- \Zend_Mail_Protocol_Pop3::connect
- \Zend_Mail::addTo
- \Zend_Form_DisplayGroup::setLayoutOutline
- \Zend_Form_DisplayGroup::setLayoutIndented
- \Zend_View_Helper_FormSelect::_build
- \Zend_Session::start