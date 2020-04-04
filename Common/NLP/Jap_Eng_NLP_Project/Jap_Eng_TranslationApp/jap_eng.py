from __future__ import division, print_function
# coding=utf-8
import sys
import os
import glob
import re
import numpy as np

# Keras
from keras.applications.imagenet_utils import preprocess_input, decode_predictions
from keras.models import load_model
from keras.preprocessing import image

# Flask utils
from flask import Flask, redirect, url_for, request, render_template
from werkzeug.utils import secure_filename
from gevent.pywsgi import WSGIServer

import tensorflow as tf
import cv2
import numpy as np
import string
import re
from pickle import dump
from unicodedata import normalize
from numpy import array
from pickle import load
from numpy import array
from numpy import argmax
from keras.preprocessing.text import Tokenizer
from keras.preprocessing.sequence import pad_sequences
# import matplotlib.pyplot as plt
# from tensorflow.keras.models import load_model

#preprocessing
from kuromojipy.kuromoji_server import KuromojiServer

def jap_clean(text):
    a = []
    with KuromojiServer() as kuro_server:
        kuromoji = kuro_server.kuromoji
        tokenizer = kuromoji.Tokenizer.builder().build()
        tokens = tokenizer.tokenize(text)
        for token in tokens:
            x = token.getSurfaceForm()+"。"+token.getAllFeatures()[0]
            a.append(x)
    # print(a)
    return " ".join(a);
    
def encode_sequences(tokenizer, length, lines):
	# integer encode sequences
	X = tokenizer.texts_to_sequences(lines)
	# pad sequences with 0 values
	X = pad_sequences(X, maxlen=length, padding='post')
	return X

# map an integer to a word
def word_for_id(integer, tokenizer):
	for word, index in tokenizer.word_index.items():
		if index == integer:
			return word
	return None

# generate target given source sequence
def predict_sequence(model, tokenizer, source):
	prediction = model.predict(source)[0]
	integers = [argmax(vector) for vector in prediction]
	target = list()
	for i in integers:
		word = word_for_id(i, tokenizer)
		if word is None:
			break
		target.append(word)
	return ' '.join(target)
    
# load a clean dataset
def load_clean_sentences(filename):
	return load(open(filename, 'rb'))

# fit a tokenizer
def create_tokenizer(lines):
	tokenizer = Tokenizer()
	tokenizer.fit_on_texts(lines)
	return tokenizer

# max sentence length
def max_length(lines):
	return max(len(line.split()) for line in lines)
    
dataset = load_clean_sentences('models/pkl/english-japanese_5-both.pkl')
train = load_clean_sentences('models/pkl/english-japanese_5-train.pkl')
test = load_clean_sentences('models/pkl/english-japanese_5-test.pkl')
# prepare english tokenizer
eng_tokenizer = create_tokenizer(dataset[:, 0])
eng_vocab_size = len(eng_tokenizer.word_index) + 1
eng_length = max_length(dataset[:, 0])
# prepare german tokenizer
jpn_tokenizer = create_tokenizer(dataset[:, 1])
jpn_vocab_size = len(jpn_tokenizer.word_index) + 1
jpn_length = max_length(dataset[:, 1])
ml = max(eng_length, jpn_length)

# Define a flask app
app = Flask(__name__)

# Model saved with Keras model.save()
MODEL_PATH = 'models/jpn_eng.h5'

# Load your trained model
# model = tf.keras.models.load_model(MODEL_PATH)
# model.compile(loss="categorical_crossentropy", optimizer='sgd', metrics=["accuracy"])
# model._make_predict_function()          # Necessary

model = load_model(MODEL_PATH)

# model = joblib.load(MODEL_PATH)

print('Model loaded. Start serving...')

# You can also use pretrained model from Keras
# Check https://keras.io/applications/
# from keras.applications.resnet50 import ResNet50
# model = ResNet50(weights='imagenet')
print('Model loaded. Check http://127.0.0.1:5000/')


def model_predict(s):
    x = array(s).reshape(1,)
    trainX = encode_sequences(jpn_tokenizer, ml, x)
    translation = predict_sequence(model,eng_tokenizer,trainX)
    return translation


@app.route('/', methods=['GET'])
def index():
    # Main page
    return render_template('index.html',translate="TRANSLATION HERE")


@app.route('/predict', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':

        w = request.form['word']
        s = jap_clean(w)
        x = array(s).reshape(1,)
        trainX = encode_sequences(jpn_tokenizer, ml, x)
        translation = predict_sequence(model,eng_tokenizer,trainX)
        t = translation

        return render_template('index.html',translate=t)   
    
    #return render_template('landing.html',username=u,img=imgs,title=ts,gen=GenList,topimg=imgstop,toptit=tstop,gen1=g1tit,gen2=g2tit,gimg1=g1img,gimg2=g2img)

# @app.route('/info', methods=['GET'])
# def info():
#     try:
#         d = "select * from diseases where Disease_Name=%s;"
#         global disease_name
#         cur.execute(d,disease_name)
#         disease_data = cur.fetchall()
#         # print(disease_data)
#         name = disease_data[0][1]
#         symp = disease_data[0][2]
#         prec = disease_data[0][3]
#     except Exception as e:
#         print("ERROR=",e)
#     return render_template('plant-info.html',n=name,s=symp,p=prec)

if __name__ == '__main__':
    # app.run(port=5002, debug=True)

    # Serve the app with gevent
    http_server = WSGIServer(('0.0.0.0',5000),app)
    http_server.serve_forever()
