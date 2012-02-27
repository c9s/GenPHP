
PHP_ARG_ENABLE({{extname}},
    [Whether to enable the "{{extname}}" extension],
    [  --enable-{{extname}}      Enable "{{extname}}" extension support])

if test $PHP_{{extname_uc}} != "no"; then
    PHP_REQUIRE_CXX()
    PHP_SUBST({{ extname_uc }}_SHARED_LIBADD)
    PHP_ADD_LIBRARY(stdc++, 1, {{ extname_uc }}_SHARED_LIBADD)
    PHP_NEW_EXTENSION({{extname}}, php_{{extname}}.c, $ext_shared)
fi
