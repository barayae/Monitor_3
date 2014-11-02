connect system/manager as sysdba;
alter system set audit_sys_operations=true  scope=spfile;
alter system set audit_trail = "DB_EXTENDED" scope=spfile;
shutdown;
startup open pfile=c:\BD1\parametros\initBD1.sql;
