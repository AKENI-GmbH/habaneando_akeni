



run:
docker compose up -d


* copy database contents vom production to testing or dev

Connect shell to postgresql docker container and run inside:

Dump prod:
pg_dump --host=backup-do-user-15562009-0.c.db.ondigitalocean.com --port=25060 --dbname=habaneando_prod --username=doadmin --password > habaneando_prod.backup

to dev:
psql --username=doadmin --dbname=habaneando-2025 --password < habaneando_prod.backup

to testing:
psql --host=app-60e97447-c09b-4c60-b904-c1abd0b2c2c4-do-user-15562009-0.m.db.ondigitalocean.com --port=25060 --username=doadmin --dbname=habaneando-2025 --password < habaneando_prod.backup



GRANT USAGE, SELECT ON ALL SEQUENCES IN SCHEMA public to "habaneando-2025";
GRANT select, insert, update ON ALL TABLES IN SCHEMA public to "habaneando-2025";