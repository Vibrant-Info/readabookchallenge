<script type="text/javascript">

    var oXHR = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

    function reportStatus() {
        if (oXHR.readyState == 4)               // REQUEST COMPLETED.
            showTheList(this.responseXML);      // ALL SET. NOW SHOW XML DATA.
    }

    oXHR.onreadystatechange = reportStatus;
    // true = ASYNCHRONOUS REQUEST (DESIRABLE), false = SYNCHRONOUS REQUEST.
    oXHR.open("GET", "http://www.goodreads.com/search/index.html?q=9780749469078&key=8qo4PHyzSrEHzIiNvWXqQg&search=all&format=json&user_id=33770104", true);
    oXHR.send();

    function showTheList(xml) {

        var divBooks = document.getElementById('books');        // THE PARENT DIV.
        var Book_List = xml.getElementsByTagName('List');       // THE XML TAG NAME.

        for (var i = 0; i < Book_List.length; i++) {

            // CREATE CHILD DIVS INSIDE THE PARENT DIV.
            var divLeft = document.createElement('div');
            divLeft.className = 'col1';
            divLeft.innerHTML = Book_List[i].getElementsByTagName("BookName")[0].childNodes[0].nodeValue;

            var divRight = document.createElement('div');
            divRight.className = 'col2';
            divRight.innerHTML = Book_List[i].getElementsByTagName("Category")[0].childNodes[0].nodeValue;

            // ADD THE CHILD TO THE PARENT DIV.
            divBooks.appendChild(divLeft);
            divBooks.appendChild(divRight);
        }
    };
</script>