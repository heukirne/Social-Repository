SELECT 
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),1,1),20,10) - CONV(SUBSTR(LPAD(function.code,8,'0'),1,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),2,1),20,10) - CONV(SUBSTR(LPAD(function.code,8,'0'),2,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),3,1),20,10) - CONV(SUBSTR(LPAD(function.code,8,'0'),3,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),4,1),20,10) - CONV(SUBSTR(LPAD(function.code,8,'0'),4,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),5,1),20,10) - CONV(SUBSTR(LPAD(function.code,8,'0'),5,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),6,1),20,10) - CONV(SUBSTR(LPAD(function.code,8,'0'),6,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),7,1),20,10) - CONV(SUBSTR(LPAD(function.code,8,'0'),7,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),8,1),20,10) - CONV(SUBSTR(LPAD(function.code,8,'0'),8,1),20,10)) as sum,
f.code, function.code
FROM Function f
JOIN Function
