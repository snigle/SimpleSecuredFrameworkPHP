echo "--------Réglages Administrateur----------"
echo "Pseudo Administrateur"
read pseudo
echo "Mot de passe de l'administrateur : "
read password
dossier=$(dirname $0)

line1=$(head -n 1 "$dossier/key.ini")
line2=$(tail -n 1 "$dossier/key.ini")
#read pass
md50=$(echo -n "0" | md5sum | sed "s/ .*//g")
key1="$md50$line1$md50"
key2="$md50$line2$md50"

final1=$(echo -n "$key1$password$key2" | sha1sum | sed "s/ .*//g")
final=$(echo -n "$final1" | md5sum | sed "s/ .*//g")



sed -i --regexp-extended "s#(<root login=\")([^\"]*)(\" .* password=\")(.*)(\")#\1$pseudo\3$final\5#1" "$dossier/app.xml"
#read pass
#md50=$(echo -n "0" | md5sum | sed "s/ .*//g")
#key1="$md50""78sq""$md50"
#key2="$md50""98zl""$md50"

#final1=$(echo -n "$key1""test""$key2" | sha1sum | sed "s/ .*//g")
#final=$(echo -n "$final1" | md5sum | sed "s/ .*//g")
#echo "$final"
