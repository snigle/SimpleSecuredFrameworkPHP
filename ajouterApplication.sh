echo "Génération des fichiers indispensables pour créer une application."
echo "--------Réglages principaux----------"
echo "Nom de l'Application : "
read app
echo "--------Réglages BDD (PDO)----------"
echo "Dao : (mysql ou postgl)"
read dao
echo "Host : "
read host
echo "DataBase : "
read db
echo "Utilisateur : "
read user
echo "Mot de passe BDD : "
read passBdd

app="${app^}"

####Copie des dossiers Default#######
cp  -r "Applications/Default/" "Applications/$app"
cp  -r "Web/Default/" "Web/$app"
chmod 766 "Applications/$app/error_log.txt"
#Renommage du fichier Default.class.php
mv "Applications/$app/Default.class.php" "Applications/$app/$app.class.php"

##Liste tout les fichiers de l'application pour remplacer Default à l'interieur
ListeRep="$(find Applications/$app/* -type f -prune)"
for file in ${ListeRep}; do
res=$(expr "$file" : ".*\.php")
if [ "$res" -gt "0" ]
then
  	sed -i -e "s/Default/$app/g" "$file"
fi
done

ListeRep="$(find Web/$app/* -type f -prune)"
for file in ${ListeRep}; do
res=$(expr "$file" : ".*\.php")
if [ "$res" -gt "0" ]
then
  	sed -i -e "s/Default/$app/g" "$file"
fi
done

###Ajout des configurations#####
sed -i --regexp-extended "s#(<pdo dao=\")(.*)(\" host=\")(.*)(\" db=\")(.*)(\" user=\")(.*)(\" password=\")(.*)(\")#\1$dao\3$host\5$db\7$user\9$passBdd\"#1" "Applications/$app/Config/app.xml"


##Génération des clés de cryptage
M="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"
while [ "${n:=1}" -le "4" ]
do  pass="$pass${M:$(($RANDOM%${#M})):1}"
  let n+=1
done
echo "$pass" > "Applications/$app/Config/key.ini"
pass=""
n=1
while [ "${n:=1}" -le "4" ]
do  pass="$pass${M:$(($RANDOM%${#M})):1}"
  let n+=1
done
echo "$pass" >> "Applications/$app/Config/key.ini"
##Genération du mot de passe
"./Applications/$app/Config/password.sh"

echo "L'application a été ajoutée avec succès, vous pouvez toujours modifier le mot de passe à l'aide du script Applications/$app/Config/password.sh et vous pouvez modifier vos paramètres BDD grâce au fichier Applications/$app/Config/app.xml ."
