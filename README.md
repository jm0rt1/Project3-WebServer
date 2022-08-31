EASY SETUP:
    Prerquisites: 
        - On windows, use a linux terminal emulator such as MINGW or Git Bash
        - On Mac, use Zsh or bash terminal (included terminal works fine and was how this program was run)
        - Setup a Database with 2 tables called...
            - "messages" ==  4 columns in order: id=int, message_body=text, sender_id=int, recipient_id=int
            - "users" == 3 columns in order: id= int, name=text, password=text
    Upload webapp to XAMPP installation:
        - open update_web_app.sh
        - set WEB_APP_PATH variable value to the desired path of the web app.
        - give update_web_app.sh, init-venv.sh and exit-on-uncommitted-changes.sh executable rights on your system
            - (NOTE: This has not been tested outside a git repository, it may be necessary to comment out line 4 in update_web_app.sh)
        - if in a git repository, commit call changes
        - run ./update_web_app.sh, from the same directory that this readme is in.
        - update_web_app.sh will install all dependencies and the code into the desired folder.