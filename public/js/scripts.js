function formatTime(e) {
    // pega elemento do evento
    var input = e.srcElement || e.target,
            // pega valor
            value = input.value;

    // tira os caracters invalidos e quebra string em partes N:1
    value = value.replace(/\D/g, '').split('');

    // pega tamanho
    vL = value.length;
    for (var i = 0; i < vL; i++) {
        // se for 1 ou 3 adiciona depois do valor ':'
        if (i == 1 || i == 3) {
            value[i] += ':';
        }
    }

    // junta tudo e coloca como valor
    input.value = value.join('');
    
    //usar: onkeyup="formatTime(event);
}