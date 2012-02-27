

#ifndef PHP_ROLLER_H
#define PHP_ROLLER_H 1
#define PHP_ROLLER_WORLD_VERSION "1.0"
#define PHP_ROLLER_WORLD_EXTNAME "roller"

PHP_FUNCTION(roller_world);

extern zend_module_entry roller_module_entry;
#define phpext_roller_ptr &roller_module_entry

#endif
