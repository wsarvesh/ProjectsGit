# Generated by Django 3.0.8 on 2020-08-19 13:15

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('chat', '0007_auto_20200819_1822'),
    ]

    operations = [
        migrations.AddField(
            model_name='game',
            name='amount',
            field=models.CharField(default='1000', max_length=500),
        ),
        migrations.AddField(
            model_name='game',
            name='worth',
            field=models.CharField(default='1000', max_length=500),
        ),
        migrations.AlterField(
            model_name='game',
            name='cost',
            field=models.CharField(default='', max_length=500),
        ),
    ]
