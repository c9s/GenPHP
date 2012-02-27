#ifdef HAVE_CONFIG_H
#include "config.h"
#endif
#include "php.h"
#include "php_{{ extname }}.h"

static function_entry {{ extname }}_functions[] = {
    PHP_FE({{extname}}_test, NULL)
    {NULL, NULL, NULL}
};

zend_module_entry {{extname}}_module_entry = {
#if ZEND_MODULE_API_NO >= 20010901
    STANDARD_MODULE_HEADER,
#endif
    PHP_{{extname_uc}}_EXTNAME,
    {{extname}}_functions,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
#if ZEND_MODULE_API_NO >= 20010901
    PHP_{{extname_uc}}_VERSION,
#endif
    STANDARD_MODULE_PROPERTIES
};

#ifdef COMPILE_DL_{{extname_uc}}
ZEND_GET_MODULE({{extname}})
#endif

PHP_FUNCTION({{extname}}_test)
{
    RETURN_STRING("Hello World", 1);
}
