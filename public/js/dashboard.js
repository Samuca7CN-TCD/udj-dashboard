$(function() {
    $("#export").on('submit', function() {
        let now = new Date();
        const day = ("00" + now.getDate()).slice(-2);
        const month = ("00" + (now.getMonth() + 1)).slice(-2);
        const year = now.getFullYear();
        const hours = ("00" + now.getHours()).slice(-2);
        const minutes = ("00" + now.getMinutes()).slice(-2);
        const seconds = ("00" + now.getSeconds()).slice(-2);
        const fulltime = day + '/' + month + '/' + year + ' às ' + hours + ':' + minutes + ':' + seconds;
        $("#last_export").text('Última exportação: ' + fulltime);
    });
});