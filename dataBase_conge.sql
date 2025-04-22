CREATE TABLE "user" (
  id SERIAL PRIMARY KEY,
  email VARCHAR(180) NOT NULL UNIQUE,
  roles JSON NOT NULL,
  password VARCHAR(255) NOT NULL,
  nom VARCHAR(50) NOT NULL,
  prenom VARCHAR(50) NOT NULL,
  solde_conges DECIMAL(5,2) DEFAULT 0,
  date_embauche DATE NOT NULL,
  manager_id INT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (manager_id) REFERENCES "user" (id)
);

CREATE TYPE conge_type AS ENUM ('PAYÉ', 'SANS SOLDE', 'MALADIE', 'RTT');
CREATE TYPE conge_statut AS ENUM ('EN_ATTENTE', 'VALIDÉ', 'REFUSÉ', 'ANNULE');

CREATE TABLE conge (
  id SERIAL PRIMARY KEY,
  user_id INT NOT NULL,
  date_debut DATE NOT NULL,
  date_fin DATE NOT NULL,
  type conge_type NOT NULL,
  statut conge_statut DEFAULT 'EN_ATTENTE',
  justificatif_filename VARCHAR(255) NULL,
  justificatif_size INT NULL,
  commentaire_employe TEXT NULL,
  commentaire_manager TEXT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES "user" (id)
);

CREATE TYPE historique_action AS ENUM ('CREATION', 'VALIDATION', 'REFUS', 'MODIFICATION', 'ANNULATION');

CREATE TABLE historique_conge (
  id SERIAL PRIMARY KEY,
  conge_id INT NOT NULL,
  user_id INT NOT NULL,
  action historique_action NOT NULL,
  details TEXT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (conge_id) REFERENCES conge (id),
  FOREIGN KEY (user_id) REFERENCES "user" (id)
);

-- Création d'un trigger pour mettre à jour automatiquement updated_at
CREATE OR REPLACE FUNCTION update_timestamp()
RETURNS TRIGGER AS $$
BEGIN
   NEW.updated_at = NOW();
   RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER update_user_timestamp
BEFORE UPDATE ON "user"
FOR EACH ROW
EXECUTE FUNCTION update_timestamp();

CREATE TRIGGER update_conge_timestamp
BEFORE UPDATE ON conge
FOR EACH ROW
EXECUTE FUNCTION update_timestamp();
);