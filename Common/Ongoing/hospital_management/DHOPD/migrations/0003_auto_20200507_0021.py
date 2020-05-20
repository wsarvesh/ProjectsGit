# Generated by Django 2.2.6 on 2020-05-06 18:51

import datetime
from django.db import migrations, models
import django.utils.timezone


class Migration(migrations.Migration):

    dependencies = [
        ('DHOPD', '0002_patient_service'),
    ]

    operations = [
        migrations.AddField(
            model_name='patient',
            name='patient_date',
            field=models.DateField(default=datetime.date.today),
        ),
        migrations.AddField(
            model_name='patient',
            name='patient_time',
            field=models.DateTimeField(auto_now_add=True, default=django.utils.timezone.now),
            preserve_default=False,
        ),
        migrations.AlterField(
            model_name='patient',
            name='patient_id',
            field=models.AutoField(max_length=200, primary_key=True, serialize=False),
        ),
        migrations.AlterField(
            model_name='service',
            name='service_id',
            field=models.AutoField(max_length=200, primary_key=True, serialize=False),
        ),
        migrations.AlterField(
            model_name='users',
            name='user_id',
            field=models.AutoField(max_length=200, primary_key=True, serialize=False),
        ),
    ]