CREATE TABLE follow (
    follower character varying(20) NOT NULL,
    author character varying(20) NOT NULL
);


--
-- Name: messages; Type: TABLE; Schema: public; Owner: ; Tablespace: 
--

CREATE TABLE messages (
    num integer NOT NULL,
    content text NOT NULL,
    author character varying(20) NOT NULL,
    date timestamp DEFAULT now() NOT NULL
);



--
-- Name: messages_num_seq; Type: SEQUENCE; Schema: public; Owner: 
--

CREATE SEQUENCE messages_num_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;



--
-- Name: messages_num_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: 
--

ALTER SEQUENCE messages_num_seq OWNED BY messages.num;


--
-- Name: users; Type: TABLE; Schema: public; Owner: ; Tablespace: 
--

CREATE TABLE users (
    ident character varying(20) NOT NULL,
    password text NOT NULL,
    name text,
    picture bytea,
    mimetype text
);



--
-- Name: num; Type: DEFAULT; Schema: public; Owner: 
--

ALTER TABLE messages ALTER COLUMN num SET DEFAULT nextval('messages_num_seq'::regclass);


--
-- Name: follow_pkey; Type: CONSTRAINT; Schema: public; Owner: ; Tablespace: 
--

ALTER TABLE ONLY follow
    ADD CONSTRAINT follow_pkey PRIMARY KEY (follower, author);


--
-- Name: messages_pkey; Type: CONSTRAINT; Schema: public; Owner: ; Tablespace: 
--

ALTER TABLE ONLY messages
    ADD CONSTRAINT messages_pkey PRIMARY KEY (num);


--
-- Name: users_pkey; Type: CONSTRAINT; Schema: public; Owner: ; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (ident);


--
-- Name: follow_author_fkey; Type: FK CONSTRAINT; Schema: public; Owner: 
--

ALTER TABLE ONLY follow
    ADD CONSTRAINT follow_author_fkey FOREIGN KEY (author) REFERENCES users(ident);


--
-- Name: follow_follower_fkey; Type: FK CONSTRAINT; Schema: public; Owner: 
--

ALTER TABLE ONLY follow
    ADD CONSTRAINT follow_follower_fkey FOREIGN KEY (follower) REFERENCES users(ident);


--
-- Name: messages_author_fkey; Type: FK CONSTRAINT; Schema: public; Owner: 
--

ALTER TABLE ONLY messages
    ADD CONSTRAINT messages_author_fkey FOREIGN KEY (author) REFERENCES users(ident);

