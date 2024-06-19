$(document).ready(function() {
    const X_CLASS = 'x';
    const O_CLASS = 'o';
    let oTurn;

    const cells = $('[data-cell]');
    const board = $('#tic-tac-toe');
    const restartButton = $('#restartButton');
    const messageElement = $('#message');

    startGame();

    restartButton.on('click', startGame);

    function startGame() {
        oTurn = false;
        cells.each(function() {
            $(this).removeClass(X_CLASS);
            $(this).removeClass(O_CLASS);
            $(this).off('click');
            $(this).one('click', handleClick);
        });
        setMessage("Player X's turn");
    }

    function handleClick(e) {
        const cell = $(e.target);
        const currentClass = oTurn ? O_CLASS : X_CLASS;
        placeMark(cell, currentClass);
        if (checkWin(currentClass)) {
            setMessage(`${currentClass.toUpperCase()} wins!`);
            cells.off('click');
        } else if (isDraw()) {
            setMessage('Draw!');
        } else {
            swapTurns();
            setMessage(`Player ${oTurn ? "O" : "X"}'s turn`);
        }
    }

    function placeMark(cell, currentClass) {
        cell.addClass(currentClass);
    }

    function swapTurns() {
        oTurn = !oTurn;
    }

    function checkWin(currentClass) {
        const WINNING_COMBINATIONS = [
            [0, 1, 2],
            [3, 4, 5],
            [6, 7, 8],
            [0, 3, 6],
            [1, 4, 7],
            [2, 5, 8],
            [0, 4, 8],
            [2, 4, 6]
        ];

        return WINNING_COMBINATIONS.some(combination => {
            return combination.every(index => {
                return cells.eq(index).hasClass(currentClass);
            });
        });
    }

    function isDraw() {
        return cells.toArray().every(cell => {
            return $(cell).hasClass(X_CLASS) || $(cell).hasClass(O_CLASS);
        });
    }

    function setMessage(message) {
        messageElement.text(message);
    }
});
