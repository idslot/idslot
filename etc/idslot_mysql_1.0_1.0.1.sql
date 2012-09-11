ALTER TABLE  `#_resume_has_skill` ADD  `sort` INT NOT NULL DEFAULT  '0' AFTER  `skill_id`;
ALTER TABLE  `#_events` ADD  `sort` INT NOT NULL DEFAULT  '0' AFTER  `type`;
ALTER TABLE  `#_publications` ADD  `sort` INT NOT NULL DEFAULT  '0' AFTER  `resume_id`;
