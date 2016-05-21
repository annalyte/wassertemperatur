# Wasser (German Version)

Wasser ist eine Web-App für iPhone, iPad und den Mac welche die Wassertemperatur des Naturfreibades in Fischach anzeigt. 

## Die Wassertemperatur und sonst nichts ##

Nicht mehr und nicht weniger. In einer eleganten Art und Weiße zeigt sie die aktuelle Wassertemperatur, ohne das ein umständlicher Besuch auf der Website des Naturfreibades notwendig ist.

## Die Temperatur ist überall ##

Außerdem ist die App dazu in der Lage, mit sozialen Netzwerken zu interagieren. Die Skripte sind dafür ausgelegt, die Wassertemperatur automatisch auf Twitter zu aktualisieren. Je nach Tageszeitung und Wassertemperatur wird dynamisch ein neuer Post generiert, sodass der Eindruck entsteht, der Bademeister würde selbst twittern. 

## Technik ##

Die App ist das Ergebnis einer jahrelangen Entwicklung und daher mittlerweile etwas kompliziert geworden. Im Folgenden erläutere ich kurz die Hauptbestandteile, die zum Funktionieren der App unbedingt notwendig sind. 

### Index ###

Das Modul INDEX ist lediglich eine Reihe von Skripten die Datenbankabfragen durchführen. In der Datei appearance.php ist ein CSS Stylesheet abgelegt, indem auch Elemente dynamisch z.B. je nach Wetterlage oder Tageszeit modifiziert werden. Dadurch ändert INDEX bei mehrmaligen Besuchen täglich sein Erscheinungsbild, um sich der aktuellen Situation im Bad anzupassen. Die Statistiken auf der Startseite werden mit jedem Aufruf dynamisch neu erzeugt und errechnet. Dies geschieht über die Skripte in script.php (SCRIPT). 

### Core ###

Das Modul CORE ist ein von INDEX völlig unabhängiges Skript (daher die eigene Versionsnummer), welches vom Nutzer niemals aufgerufen wird. Die Informationen auf core.php dienen lediglich der Diagnose und sollen bei der Fehlerbehebung helfen. 

Der CORE basiert auf dem Skript simple_html_dom.php von Jose Solorzano. Dieses Skript interpretiert die Website naturfreibad-fischach.de und filtert die HTML-Elemente mit der Wassertemperatur heraus. Dieses Array wird anschließend gefiltert (preg_replace) und abgeschnitten (array_slice). Die Werte werden in einer mysql-Datenbank abgespeichert. Durch einen Cronjob wird das Skript im 30-Minuten-Takt aufgerufen. Mit jedem neuen Aufruf entsteht ein neuer Eintrag in der Datenbank. Dieser Rhythmus ist einzuhalten, damit die Durchschnittswerte ordnungsgemäß berechnet werden können. 

Das Skript gleicht mit jedem Aufruf die auf der Website vorhandenen Werte mit denen davor in der Datenbank abgespeicherten und löst im Fall eines neuen Wertes andere Funktionen aus: Bei einer neuen Temperatur wird beispielsweise ein neuer Tweet generiert, ein neuer Eintrag in eine XML-Datei geschrieben und ein neuer UNIX-Zeitstempel eingetragen, um die relative Datumsanzeige in index.php zu ermöglichen. 

CORE wird standardmäßig im Debug-Modus ausgeführt, d.h. es werden keine Daten in die Datenbank geschrieben und keine weiteren Aktionen ausgelöst. Dies soll ermöglichen Fehler im Parser zu finden, ohne die Datenbank zu stark zu verfälschen. 

CORE trägt jeden neuen Wert in eine XML-Datei namens database.xml ein, um eine mögliche interoperabilität in der Zukunft mit anderen Diensten einfacher zu machen. Diese Funktion wird im Moment jedoch nicht mehr verwendet. 

Seit Version 1.4.4 generiert CORE vollständig eigenständig die Zeitstempel, um nicht mehr abhängig von den fehlerbehafteten Angeben auf der Website abhängig zu sein. Seit 1.4.3 kann CORE Temperaturen als Dezimalwerte abspeichern. 

CORE wird vom Modul FASTTRACK ergänzt, welches eine schnellere Aktualisierung der Temperatur auf INDEX erlaubt: Da FASTTRACK nicht von dem strikten 30-Minuten-Rhythmus abhängig ist und alle fünf Minuten aufgerufen wird, kann er schneller auf Änderungen reagieren. FASTTRACK ist jedoch wesentlich vereinfacht, schreibt keine Statistiken und stellt keine Schnittstelen zu anderen Diensten bereit.  

Um die dynamischen Texte für die Tweets und INDEX zu generieren greift CORE auf Muster in TEXTS zurück.  

# Eau (Version Française)

Eau est une application mobile pour iPhone, iPad et Mac pour afficher la température de l'eau dans votre piscine locale. 

# Water (English Version)

Water is a web-application for iPhone, iPad and Mac which shows the water-temperature of your local swimming-pool. 