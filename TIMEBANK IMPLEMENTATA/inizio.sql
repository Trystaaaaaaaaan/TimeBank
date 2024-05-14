-- Creazione del database
DROP DATABASE if exists ScambioInsegnamenti;
CREATE DATABASE if not exists ScambioInsegnamenti;

USE ScambioInsegnamenti;

-- Tabella Utenti
CREATE TABLE Utenti (
                        ID INT PRIMARY KEY auto_increment not null,
                        Nome VARCHAR(255) NOT NULL,
                        Mail VARCHAR(255) NOT NULL,
                        Password VARCHAR(255) NOT NULL,
                        Punti INT DEFAULT 3
);

-- Tabella Insegnanti (figlia di Utenti)
CREATE TABLE Insegnanti (
                            ID INT PRIMARY KEY,
                            Materie VARCHAR(255) NOT NULL,
                            FOREIGN KEY (ID) REFERENCES Utenti(ID)
);

-- Tabella Corsi
CREATE TABLE Corsi (
                       ID INT AUTO_INCREMENT PRIMARY KEY,
                       Materia VARCHAR(255) NOT NULL,
                       InsegnanteID INT,
                       Descrizione varchar(255),
                       FOREIGN KEY (InsegnanteID) REFERENCES Insegnanti(ID)
);

-- Tabella Prenotazioni
CREATE TABLE Prenotazioni (
                              ID  INT auto_increment PRIMARY KEY ,
                              UtenteID INT,
                              CorsoID INT,
                              FOREIGN KEY (UtenteID) REFERENCES Utenti(ID),
                              FOREIGN KEY (CorsoID) REFERENCES Corsi(ID)
);



-- Tabella Recensioni
CREATE TABLE Recensioni (
                            ID INT PRIMARY KEY,
                            UtenteID INT,
                            CorsoID INT,
                            Voto DECIMAL(3, 2),
                            Commento TEXT,
                            FOREIGN KEY (UtenteID) REFERENCES Utenti(ID),
                            FOREIGN KEY (CorsoID) REFERENCES Corsi(ID)
);
USE ScambioInsegnamenti;
INSERT INTO Utenti(ID, Nome, Mail, Password, Punti)
    VALUES (1234, 'Giorgio Vanni', 'giorgio.vanni@xnxx.com', '123456', 3);
INSERT INTO Insegnanti(ID, Materie)
    VALUES (1234, 'Matematica');
INSERT INTO Corsi(ID, Materia, InsegnanteID, Descrizione)
    VALUES (246, 'Matematica', 1234, 'corso di matematica');



select *
from Prenotazioni as P
         join Corsi as C on P.CorsoID = C.ID
where C.InsegnanteID = 1234 and C.ID = 246;


delete from Prenotazioni where UtenteID = 1242 and CorsoID = 246;

DELIMITER //
create trigger aumenta_punti
    after insert on Prenotazioni
    for each row
    begin
        update Utenti u
        inner join Corsi c on u.ID = c.InsegnanteID
        set u.Punti = u.Punti + 3
        Where c.ID = NEW.CorsoID;
    end; //
DELIMITER ;

DELIMITER //
CREATE TRIGGER diminuisci_punti
    BEFORE INSERT ON Prenotazioni
    FOR EACH ROW
BEGIN
    -- Verifica se i punti dopo l'aggiornamento saranno uguali a 0
    IF (SELECT Punti FROM Utenti WHERE id = NEW.UtenteID) - 1 = -1 THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Errore: Non è possibile avere un punteggio uguale a zero.';
    ELSE
        -- Aggiorna i punti solo se non sono uguali a 0
        UPDATE Utenti
        SET Punti = Punti - 1
        WHERE id = NEW.UtenteID;
    END IF;
END; //
DELIMITER ;


DELIMITER //
CREATE TRIGGER rimetti_punti
    AFTER delete ON Prenotazioni
    FOR EACH ROW
BEGIN
    UPDATE Utenti
    SET Punti = Punti + 1
    WHERE id = OLD.UtenteID;
END; //
DELIMITER ;


DELIMITER //
create trigger togli_aumenta_punti
    after delete on Prenotazioni
    for each row
begin
    update Utenti u
        inner join Corsi c on u.ID = c.InsegnanteID
    set u.Punti = u.Punti - 3
    Where c.ID = OLD.CorsoID;
end; //
DELIMITER ;


drop trigger aumenta_punti;
drop trigger diminuisci_punti;