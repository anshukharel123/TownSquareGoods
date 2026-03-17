FUNCTION AUTH 
  (p_username VARCHAR2,  
   p_password VARCHAR2) 
RETURN BOOLEAN 
IS 
   ps varchar2(255);
  l_user_exist   NUMBER; 
  l_user_name    VARCHAR2(255) := UPPER(p_username);
BEGIN 
  -- Hash the plain text password
  ps := UTL_RAW.CAST_TO_RAW(DBMS_OBFUSCATION_TOOLKIT.MD5(input_string => p_password));

  -- Check if the user exists in the TRADER table
  SELECT COUNT(*)  
  INTO l_user_exist  
  FROM users 
  WHERE UPPER(Username) = l_user_name AND upper(password) = upper(ps) and USER_ROLE = 'trader'; 

  -- If the user exists
  IF l_user_exist > 0 THEN 
    RETURN TRUE;
  ELSE 
    RETURN FALSE; 
  END IF; 
EXCEPTION 
  -- Handle specific exceptions if needed
  WHEN NO_DATA_FOUND THEN
    RETURN FALSE;
  WHEN OTHERS THEN
    RETURN FALSE;
END AUTH;