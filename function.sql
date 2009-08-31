-- Set Complextype idType
UPDATE ComplexType c SET c.idType = (SELECT t.id FROM type t WHERE t.name = c.name AND (t.idWebService = 0) LIMIT 1) WHERE c.idType IS NULL;
UPDATE ComplexType c SET c.idType = (SELECT t.id FROM type t WHERE t.name = c.name AND (t.idWebService = c.idWebService) LIMIT 1) WHERE c.idType IS NULL;

--Recursive Query for Type Update Code
UPDATE ComplexType c SET code = (SELECT CONV(sum(CONV(code,20,10)*1),10,20) FROM Type t WHERE t.id = c.idType AND t.idWebService = c.idWebService);
UPDATE Type t SET code = (SELECT CONV(sum(CONV(code,20,10)*1),10,20) FROM ComplexType c WHERE t.id = c.id) WHERE t.id IN (SELECT id FROM ComplexType);

--Query for Functions Code by Params
UPDATE Function f SET f.code = ( SELECT CONV(sum(CONV(code,20,10)*1),10,20) FROM Params p INNER JOIN Type t ON t.id = p.idType WHERE idFunction = f.id);

-- Diff of Functions
SELECT 
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),1,1),20,10) - CONV(SUBSTR(LPAD(function.code,8,'0'),1,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),2,1),20,10) - CONV(SUBSTR(LPAD(function.code,8,'0'),2,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),3,1),20,10) - CONV(SUBSTR(LPAD(function.code,8,'0'),3,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),4,1),20,10) - CONV(SUBSTR(LPAD(function.code,8,'0'),4,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),5,1),20,10) - CONV(SUBSTR(LPAD(function.code,8,'0'),5,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),6,1),20,10) - CONV(SUBSTR(LPAD(function.code,8,'0'),6,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),7,1),20,10) - CONV(SUBSTR(LPAD(function.code,8,'0'),7,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),8,1),20,10) - CONV(SUBSTR(LPAD(function.code,8,'0'),8,1),20,10)) as diff,
f.code, function.code
FROM Function f
JOIN Function
