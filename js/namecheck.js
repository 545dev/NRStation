function controllaNome() {
    var nome = document.getElementById("fileToUpload").value;
    var pattern = "~`!#$%^&*+=-[]\\\';,/{}|\":<>?";
    if (pattern.test(nome)) {
        alert("Il nome del file che vuoi caricare contiene caratteri speciali");
        return false;
    }
    return true;
}
