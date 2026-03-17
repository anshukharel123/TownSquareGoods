**🚀 Oracle APEX Setup Guide (Local Environment)**
 
This guide explains how to install Oracle Database 11g XE and configure Oracle Application Express (APEX) on your local machine.

📥 1. Download Oracle Database
- Visit: https://www.oracle.com/database/technologies/xe-downloads.html  
- Check your system type:
- Open **System Information**
- Look for **System Type (32-bit / 64-bit)**
- Download the appropriate version
- Sign in with your Oracle account
- Run the installer and complete setup

⚙️ 2. Setup Oracle APEX
  Step 1: Navigate to APEX Directory
   -Open Command Prompt and run:
     1. bash
     2. cd apex
     3. sqlplus /nolog
     4. CONNECT SYS AS SYSDBA
     5. @apexins SYSAUX SYSAUX TEMP /i/
     6. @apex_epg_config.sql C:\ **Replace C:\ with your APEX unzip directory if different**
     7. @apxchpwd (After this you are able to have your Admin email address and password)**Remember this**
     8. In broweser open this http://localhost:8080/apex/apex_admin.
    Write your username and password that you set up in number 7 step
     9. Now after you login you need to create your Admin User so again Your need write your username that will be provided in your email passsword and email to create your shop.
     10. http://127.0.0.1:8080/apex/ (Login to Apex)

**XAMPP SetUp Guide**
1. Download XAMPP
-Go to the official website: XAMPP Downloads link https://www.apachefriends.org/download.html
-Download the latest version compatible with your Windows OS.
2. Run the Installer
-Locate the downloaded .exe file.
-Double-click the file to start the installation.
3. Start the Setup Wizard
-After running the installer, the setup wizard will appear automatically.
-Click Next to proceed.
4. Choose Software Components
You will see a list of components to install.
For full functionality, it is recommended to install all components.
Click Next to continue.
5. Choose Installation Directory
Select the folder where XAMPP should be installed.
The default is usually C:\xampp.
Click Next to continue.
6. Start Installation
Click Next to begin the installation.
The process may take several minutes as all components are unpacked and configured.
7. Complete Installation
Once the installation is finished, click Finish.
XAMPP is now ready to use.
8. Edit Environment Variables (Optional but Recommended)
-Add the path to the XAMPP installation directory (e.g., C:\xampp) to your system PATH environment variable.
-This allows you to run XAMPP tools from any command prompt.
9. Using the XAMPP Control Panel
-Open the XAMPP Control Panel from the installation directory or Start menu.
-Ready to use
