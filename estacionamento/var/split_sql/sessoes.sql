-- Arquivo gerado automaticamente para tabela `sessoes`
-- Fonte: banco.sql

CREATE TABLE IF NOT EXISTS sessoes (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  placa TEXT NOT NULL,
  entrada TEXT NOT NULL,
  saida TEXT NULL,
  valor REAL NULL,
  ativa INTEGER NOT NULL DEFAULT 1,
  FOREIGN KEY (placa) REFERENCES veiculos(placa)
);

