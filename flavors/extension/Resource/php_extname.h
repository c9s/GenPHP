

#ifndef PHP_{{extname_uc}}_H
#define PHP_{{extname_uc}}_H 1
#define PHP_{{extname_uc}}_VERSION "1.0"
#define PHP_{{extname_uc}}_EXTNAME "{{extname}}"

PHP_FUNCTION({{extname}}_test);

extern zend_module_entry {{extname}}_module_entry;
#define phpext_{{extname}}_ptr &{{extname}}_module_entry

#endif
