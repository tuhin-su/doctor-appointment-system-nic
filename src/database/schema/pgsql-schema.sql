CREATE TABLE migrations(
    id SERIAL NOT NULL,
    migration varchar(255) NOT NULL,
    batch integer NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE cache(
    "key" varchar(255) NOT NULL,
    "value" text NOT NULL,
    expiration integer NOT NULL,
    PRIMARY KEY(key)
);

CREATE TABLE cache_locks(
    "key" varchar(255) NOT NULL,
    owner varchar(255) NOT NULL,
    expiration integer NOT NULL,
    PRIMARY KEY(key)
);

CREATE TABLE sessions(
    id varchar(255) NOT NULL,
    user_id bigint,
    ip_address varchar(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL,
    PRIMARY KEY(id)
);
CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);
CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);

CREATE TABLE password_reset_tokens(
    email varchar(255) NOT NULL,
    token varchar(255) NOT NULL,
    created_at timestamp without time zone,
    PRIMARY KEY(email)
);

CREATE TABLE jobs(
    id SERIAL NOT NULL,
    queue varchar(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL,
    PRIMARY KEY(id)
);
CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);

CREATE TABLE job_batches(
    id varchar(255) NOT NULL,
    name varchar(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer,
    PRIMARY KEY(id)
);

CREATE TABLE failed_jobs(
    id SERIAL NOT NULL,
    uuid varchar(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp without time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id)
);
CREATE UNIQUE INDEX failed_jobs_uuid_unique ON public.failed_jobs USING btree (uuid);

CREATE TABLE notifications(
    id uuid NOT NULL,
    "type" varchar(255) NOT NULL,
    notifiable_type varchar(255) NOT NULL,
    notifiable_id bigint NOT NULL,
    "data" text NOT NULL,
    read_at timestamp without time zone,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    PRIMARY KEY(id)
);
CREATE INDEX notifications_notifiable_type_notifiable_id_index ON public.notifications USING btree (notifiable_type, notifiable_id);


CREATE TABLE users(
    id SERIAL NOT NULL,
    name varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    email_verified_at timestamp without time zone,
    profile_image text,
    password varchar(255) NOT NULL,
    remember_token varchar(100),
    role user_role NOT NULL DEFAULT 'Patient'::user_role,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    PRIMARY KEY(id)
);
CREATE UNIQUE INDEX users_email_unique ON public.users USING btree (email);


CREATE TABLE doctors(
    id SERIAL NOT NULL,
    user_id SERIAL NOT NULL,
    verified_degree boolean DEFAULT false,
    specialty varchar(255) NOT NULL,
    job_started date NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    PRIMARY KEY(id),
    CONSTRAINT doctors_user_id_fkey FOREIGN key(user_id) REFERENCES users(id)
);

CREATE TABLE work_schedule(
    id SERIAL NOT NULL,
    doctor_id SERIAL NOT NULL,
    day varchar(255) NOT NULL,
    start_time time without time zone NOT NULL,
    end_time time without time zone NOT NULL,
    break_start time without time zone,
    break_end time without time zone,
    enabled boolean DEFAULT true,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    PRIMARY KEY(id),
    CONSTRAINT work_schedule_doctor_id_fkey FOREIGN key(doctor_id) REFERENCES doctors(id)
);

CREATE TABLE appointments_booking(
    id SERIAL NOT NULL,
    user_id bigint NOT NULL,
    doctor_id bigint NOT NULL,
    doctor_user_id bigint NOT NULL,
    "date" date NOT NULL,
    booking_time time without time zone NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    reschedule_status varchar(20) DEFAULT 'booked'::character varying,
    reschedule_by varchar(200),
    reschedule_date date,
    reschedule_time time without time zone,
    CONSTRAINT appointments_booking_reschedule_status_check CHECK (((reschedule_status)::text = ANY (ARRAY[('pending'::character varying)::text, ('approved'::character varying)::text, ('declined'::character varying)::text, ('completed'::character varying)::text, ('booked'::character varying)::text, ('cancelled'::character varying)::text])))
);